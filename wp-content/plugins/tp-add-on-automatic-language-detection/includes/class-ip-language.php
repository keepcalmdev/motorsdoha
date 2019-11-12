<?php
class TRP_IP_Language {

    /**
     * Return the language code that matches best with IP detected language.
     * Returns null if no matches are found.
     *
     * @param $published_languages array       TranslatePress settings['publish-languages']
     * @param $iso_codes array                 Iso codes of the published languages
     * @return string | null
     */
	public function get_ip_language( $published_languages, $iso_codes ){
	    $return = null;
		$ip_country = $this->get_country_iso_code();
		foreach( $published_languages as $language_code ){
		    $language_code_country = $this->get_country_for_language_code( $language_code );
            if ( strtolower( $ip_country ) == strtolower( $language_code_country ) ){
                $return = $language_code;
                break;
            }
        }
        return $return;
	}

    /**
     * Return the iso code of the country encoded in the given language code.
     * Return empty string if none found.
     *
     * @param $language_code string         Language code
     * @return string
     */
	public function get_country_for_language_code( $language_code ){
	    $country_code = '';

	    // if code has character _
        if ( ( $pos = strpos( $language_code, "_" ) ) !== false ) {
            // strip code of language, remove everything before character _
            $country_code = substr( $language_code, $pos + 1 );
            // strip everything after the character _ , if exists
            $country_code = strpos($country_code, "_") ? substr($country_code, 0, strpos($country_code, "_")) : $country_code;
        }
        return $country_code;
    }

	/**
	 * Return current IP.
	 *
	 * Based on https://stackoverflow.com/a/55790
	 *
	 * @return string
	 */
    public function get_current_ip(){
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else {
		    $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    if ( ! filter_var($ip, FILTER_VALIDATE_IP ) ) {
		    // $ip not a valid IP address. Set to a dummy local address.
		    $ip = "127.0.0.1";
	    }

		return $ip;
    }

	/**
	 * Return true if IP current IP is found in DB
	 *
	 * @return bool
	 */
    public function found_ip_in_database(){
	    $ip_country = $this->get_country_iso_code();
	    if ( empty ($ip_country ) ){
		    // not valid IP address
		    return false;
	    } else {
		    // valid IP address
		    return true;
	    }
    }

    /**
     * Return iso code of country determined from IP.
     * Return null if not found.
     *
     * Uses GeoLite2 database.
     *
     * @return string | null
     */
	public function get_country_iso_code(){
        require( __DIR__ . '/../assets/lib/autoload.php' );
        require( __DIR__ . '/../assets/lib/TP_MaxMind/Db/Reader.php' );
        require( __DIR__ . '/../assets/lib/TP_MaxMind/Db/Reader/Decoder.php' );
        require( __DIR__ . '/../assets/lib/TP_MaxMind/Db/Reader/InvalidDatabaseException.php' );
        require( __DIR__ . '/../assets/lib/TP_MaxMind/Db/Reader/Metadata.php' );
        require( __DIR__ . '/../assets/lib/TP_MaxMind/Db/Reader/Util.php' );

        // This WP filter does not work when the redirect is triggered from the front-end ( i.e. when caching is on )
        $db_path = __DIR__ . '/../assets/lib/GeoLite2-Country/GeoLite2-Country.mmdb';
        $reader = new TP_MaxMind\Db\Reader( $db_path );

		$ip = $this->get_current_ip();
        $record = $reader->get( $ip );
        $country_code = null;
        if ( !empty( $record ) && !empty( $record['country'] ) && !empty( $record['country']['iso_code'] ) ){
            $country_code = $record['country']['iso_code'];
        }

        return $country_code;
    }
}
