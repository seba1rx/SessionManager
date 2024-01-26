<?php declare(strict_types=1);

namespace Seba1rx;

/**
 * extend this class to customize it by creating your own constructor
 *
 * this class is defined as abstract to force implementing a class extending this class to define a constructor
 *
 * there are no abstract methods in this class, but it is intended to be implemented with a custom constructor.
 */
abstract class SessionAdmin{

    const IP_REGEX = '/(\d{1,3}\.\d{1,3}\.\d{1,3}\.)(\d{1,3})/';
    protected $sessionLifetime = 2400;
    protected $sessionName = 'SESSION';
    protected $allowedUrls = ['index.php'];
    protected $keys = [];
    private $path = '/';
    private $domain = NULL;
    private $secure = NULL;
    private $uniqueId;
    private $breadcrumbs = [];

    /**
     * Extend this class and define the constructor as you want to implement this class.
     * The first page to instantiate this class can pass an array to setup the object.
     *
     * $sessionAdmin = \Seba1rx\SessionAdmin(
     *     [
     *          "sessionLifetime" => 3600,
     *          "allowedURLs" => ["index.php", "legal.php", "contact_us.php", "our_history.php", "products_and_plans.php"],
     *          "keys" => [
     *              "some_key" => "some_value",
     *              "foo" => "bar",
     *          ],
     *     ]
     * );
     * $sessionAdmin->activateSession(); // this is like session_start()
     */

    /**
     * fn activateSession:
     * starts a new session as guest or renewes user session if $_SESSION['uniqueId'] is set
     */
    public function activateSession(): void
    {
        session_name($this->sessionName);
        $this->setSessionTime();
        session_start();
        $this->setSessionTimeStamps();

        if(isset($_SESSION['uniqueId'])){
            # user
            $this->checkTime();
        }else{
            # guest
            $this->configureGuestSession();
        }

        $this->checkIfUrlIsAllowed();

        foreach($this->keys as $key => $item){
            if(!isset($_SESSION[$key])){
                $_SESSION[$key] = $item;
            }
        }
    }

    /**
     * fn createUserSession:
     * adds user data to SESSION and sets time
     * @param int $id_user
     */
    public function createUserSession(int $id_user): void
    {
        $this->uniqueId = base_convert(microtime(false), 10, 36);

        $_SESSION['isUser'] = TRUE;
        $_SESSION['msg'] = 'you are a user';
        $_SESSION['uniqueId'] = $this->uniqueId;
        $_SESSION['id_user'] = $id_user;
        $_SESSION['urlIsAllowedToLoad'] = FALSE;

        $this->setSessionTime();
        $this->setSessionTimeStamps();
    }

    /**
     * fn configureGuestSession:
     * configure $_SESSION with guest data which is the minimum data to use the website
     */
    private function configureGuestSession(): void
    {
        // we save important stuff before resetting session
        if(isset($_SESSION['breadcrumbs'])){
            $this->breadcrumbs = $_SESSION['breadcrumbs'];
        }

        // setting / resetting session
        $_SESSION = [];
        $_SESSION['isUser'] = FALSE;
        $_SESSION['msg'] = 'you are a guest';
        $_SESSION['allowedUrl'] = $this->allowedUrls;
        $_SESSION['breadcrumbs'] = $this->breadcrumbs;
        $_SESSION['urlIsAllowedToLoad'] = FALSE; // by default
    }

    /**
     * fn preparesDomainAndSecureVars
     * Set the domain to current domain if not set
     * Set the secure value to whether the site is being accessed with SSL
     * @return void
     */
    private function preparesDomainAndSecureVars(): void
    {
        $this->domain = $this->domain ?? $_SERVER['SERVER_NAME'];
        $this->secure = $this->secure ?? isset($_SERVER['HTTPS']);
    }

    /**
     * fn setSessionTime:
     * updates the available session time
     * @return void
     */
    private function setSessionTime(): void
    {
        // refresh expire time of session
        if (isset($_COOKIE[$this->sessionName])){
            setcookie($this->sessionName, $_COOKIE[$this->sessionName], time() + $this->sessionLifetime, "/");
        }

        // sets expire time (when creating session only)
        if(!isset($_SESSION)) {
            $this->preparesDomainAndSecureVars();
            session_set_cookie_params($this->sessionLifetime, $this->path, $this->domain, $this->secure, true);
            ini_set('session.gc_maxlifetime',(string)$this->sessionLifetime);
        }
    }

    /**
     * fn setSessionTimeStamps:
     * sets session time vars used to calculate whether request is obsolete
     * session always exists when this function is called
     */
    private function setSessionTimeStamps(): void
    {
        $time = time();
        $previous = time();
        if(isset($_SESSION['time_atRequest'])){
            $previous = $_SESSION['time_atRequest'];
        }
        $_SESSION['time_atRequest'] = $time;
        $_SESSION['time_sinceLastRequest'] = $time - $previous;
    }

    /**
     * fn requestIsObsolete
     * @return bool true if request is obsolete
     */
    private function requestIsObsolete(): bool
    {
        return ($_SESSION['time_sinceLastRequest'] > $this->sessionLifetime ? TRUE : FALSE);
    }

    /**
     * fn checkTime:
     * calls to destroySession if request is obsolete
     * session always exists when this function is called
     * if request is still on time, check if request is hijacking attempt
     */
    private function checkTime(): void
    {
        if($this->requestIsObsolete()){
            $this->destroySession();
        }else{

            if ($this->requestIsHijackingAttempt()) {

                // Reset session data and regenerate id
                $_SESSION = [];
                $_SESSION['ipAddress'] = $this->getIpAddress();
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
                $this->regenerateSession();

                // Give a 3% chance of the session id changing on any request
            } elseif ($this->shouldRandomlyRegenerate()) {
                $this->regenerateSession();
            }
        }
    }

    /**
     * fn destroySession:
     * clears $_SESSION, destroys current session, and calls to start new session as guest
     */
    private function destroySession(): void
    {
        if(isset($_SESSION)){
            $_SESSION = [];
            session_write_close();
            session_destroy();
            $this->activateSession();
        }
    }

    /**
     * fn checkIfUrlIsAllowed:
     * Checks if url that originated the request is in allowd URL array
     * This check is done when an url is requested or when an XHR request is sent to the server
     * This evaluation only marks TRUE when allowed, FALSE by default
     */
    private function checkIfUrlIsAllowed(): void
    {
        $_SESSION['urlIsAllowedToLoad'] = FALSE;
        $url_to_check = basename($_SERVER['PHP_SELF']);
        foreach($_SESSION['allowedUrl'] AS $allowed){
            $url_to_compare_against = $this->getSubStrAfter('/',$allowed);
            if($url_to_check == $url_to_compare_against){
                $_SESSION['urlIsAllowedToLoad'] = TRUE;
                break;
            }
        }
    }

    /**
     * fn requestIsHijackingAttempt
     * @return bool true if hijicking detected, false ok
     */
    private function requestIsHijackingAttempt(): bool
    {
        $ipAddress = $this->getIpAddress();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (!isset($_SESSION['ipAddress']) || !isset($_SESSION['userAgent'])) {
            return false;
        }

        if ($_SESSION['ipAddress'] != $ipAddress) {
            return false;
        }

        if ($_SESSION['userAgent'] !== $userAgent) {
            return false;
        }

        return true;
    }

    /**
     * fn getIpAddress
     * If a site goes through the likes of Cloudflare, the last part of the IP might change
     * So we replace it with an x.
     *
     * @return string
     */
    private function getIpAddress(): string
    {
        $remoteAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        return preg_replace(self::IP_REGEX, '$1x', $remoteAddress);
    }

    /**
     * fn regenerateSession
     * Creates a fresh session Id to make it harder to hack
     * @return void
     */
    private function regenerateSession(): void
    {
        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();
    }

    /**
     * fn shouldRandomlyRegenerate
     * 3% chances of returning true on each request
     * @return bool
     */
    private function shouldRandomlyRegenerate(): bool
    {
        return rand(1, 100) <= 3;
    }

    /**
     * fn getSubStrAfter
     * gets substring after last occurance of given string
     * example: getSubStrAfter('[', 'sin[90]*cos[180]') -> returns '180]' #from the last occurrence of '['
     * @param string subStr         the string to search for
     * @param string mainString     the complete string
     * @return string
     */
    private function getSubStrAfter (string $subStr, string $mainString): string
    {
        if (!is_bool($this->strrevpos($mainString, $subStr))){
            return substr($mainString, $this->strrevpos($mainString, $subStr)+strlen($subStr));
        }else{
            return $mainString;
        }
    }

    /**
     * fn strrevpos
     * use strrevpos function in case your php version does not include it
     * @param string mainStr     the srting where to look for the needle
     * @param string needle      the needle
     * @return mixed
     */
    private function strrevpos(string $mainStr, string $needle)
    {
        $rev_pos = strpos (strrev($mainStr), strrev($needle));
        if($rev_pos===false){
            return false;
        }else{
            return strlen($mainStr) - $rev_pos - strlen($needle);
        }
    }
}
