<?php
/**
 *   VGallery: CMS based on FormsFramework
Copyright (C) 2004-2015 Alessandro Stucchi <wolfgan@gmail.com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

 * @package VGallery
 * @subpackage core
 * @author Alessandro Stucchi <wolfgan@gmail.com>
 * @copyright Copyright (c) 2004, Alessandro Stucchi
 * @license http://opensource.org/licenses/gpl-3.0.html
 * @link https://github.com/wolfgan43/vgallery
 */
class anagraphAccess
{
	const TYPE                                              = "access";
	const MAIN_TABLE                                        = "users";

   /* private static $services								= array(
																"sql" 					        => null
																//, "nosql"						=> null
																//, "fs" 						    => null
															);*/
    private static $connectors								= array(
																"sql"                           => array(
																	"host"          		    => null
																	, "username"    		    => null
																	, "password"   			    => null
																	, "name"       			    => null
																	, "prefix"				    => "ANAGRAPH_ACCESS_DATABASE_"
																	, "table"                   => null
																	, "key"                     => "ID"
																)
																, "nosql"                       => array(
																	"host"          		    => null
																	, "username"    		    => null
																	, "password"    		    => null
																	, "name"       			    => null
																	, "prefix"				    => "ANAGRAPH_ACCESS_MONGO_DATABASE_"
																	, "table"                   => null
																	, "key"                     => "ID"
																	)
																, "fs"                          => array(
																	"service"				    => "php"
																	, "path"                    => "/cache/access"
																	, "name"                    => array("username_slug")
                                                                )
															);
    private static $struct								    = array(
	                                                            "users" => array(
	                                                                "ID"                        => "primary"
                                                                    , "ID_domain"               => "number"
                                                                    , "acl"                     => "number"
                                                                    , "acl_primary"             => "string"
                                                                    , "acl_profile"             => "string"
                                                                    , "expire"                  => "number"
                                                                    , "status"                  => "number"
                                                                    , "username"                => "string"
                                                                    , "username_slug"           => "string"
                                                                    , "email"                   => "string"
                                                                    , "tel"                     => "string"
                                                                    , "password"                => "string:inPassword"
                                                                    , "avatar"                  => "string"
                                                                    , "created"                 => "number"
                                                                    , "last_update"             => "number"
                                                                    , "last_login"              => "number"
                                                                    , "ID_lang"                 => "number"
                                                                    , "SID"                     => "string:inPassword"
                                                                    , "SID_expire"              => "number"
                                                                    , "SID_device"              => "number"
                                                                    , "SID_ip"                  => "string"
                                                                    , "SID_question"            => "string"
                                                                    , "SID_answer"              => "string:inPassword"
                                                                )
                                                                , "groups" => array(
                                                                    "ID"                        => "primary"
                                                                    , "name"                    => "string"
                                                                    , "level"                   => "number"
                                                                )
                                                                , "user_groups" => array(
                                                                    "ID"                        => "primary"
                                                                    , "ID_user"                 => "number"
                                                                    , "ID_group"                => "number"
                                                                )
                                                                , "devices" => array(
                                                                    "ID"                        => "primary"
                                                                    , "client_id"               => "string"
                                                                    , "ID_user"                 => "number"
                                                                    , "name"                    => "string"
                                                                    , "type"                    => "string"
                                                                    , "last_update"             => "number"
                                                                    , "hits"                    => "number"
                                                                    , "ips"                     => "text"
                                                                )
                                                                , "tokens" => array(
                                                                    "ID"                        => "primary"
                                                                    , "ID_user"                 => "number"
                                                                    , "type"                    => "string"
                                                                    , "token"                   => "string"
                                                                    , "expire"                  => "number"
                                                                    , "refresh_token"           => "number"
                                                                    , "ID_remote"               => "number"

                                                                )
															);
    private static $relationship							= array(
                                                                "users"                         => array(
                                                                    "acl"                       => array(
                                                                        "tbl"                       => "groups"
                                                                        , "key"                     => "ID"
                                                                    )
                                                                    , Anagraph::TYPE              => array(
                                                                        "external"                  => "ID_user"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                    , "tokens"                  => array(
                                                                        "external"                  => "ID_user"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                    , "user_groups"                  => array(
                                                                        "external"                  => "ID_user"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                )
                                                                , "devices"                     => array(
                                                                    "users"                     => array(
                                                                        "external"                  => "ID_user"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                )
                                                                , "tokens"                      => array(
                                                                    "users"                     => array(
                                                                        "external"                  => "ID_user"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                )
                                                                , "groups"                      => array(
                                                                    anagraphAccess::MAIN_TABLE  => array(
                                                                        "external"                  => "acl"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                )
                                                                , "user_groups" => array(
                                                                    anagraphAccess::MAIN_TABLE  => array(
                                                                        "external"                  => "ID_user"
                                                                        , "primary"                 => "ID"
                                                                    )
                                                                )
                                                            );
    private static $indexes                                 = array(
                                                                "users"                         => array(
                                                                    "ID_domain"                 => "hardindex"
                                                                    , "acl"                     => "hardindex"
                                                                )
                                                                , "devices"                     => array(
                                                                    "ID_user"                   => "hardindex"
                                                                )
                                                                , "tokens"                      => array(
                                                                    "ID_user"                   => "hardindex"
                                                                )
                                                            );
    private static $tables                                  = array(
                                                                "users"                         => array(
                                                                    "name"                      => "access_users"
                                                                    , "alias"                   => "user"
                                                                    , "engine"                  => "InnoDB"
                                                                    , "crypt"                   => false
                                                                    , "pairing"                 => false
                                                                    , "transfert"               => false
                                                                    , "charset"                 => "utf8"
                                                                )
                                                                , "groups"                      => array(
                                                                    "name"                      => "access_groups"
                                                                    , "alias"                   => "group"
                                                                    , "engine"                  => "InnoDB"
                                                                    , "crypt"                   => false
                                                                    , "pairing"                 => false
                                                                    , "transfert"               => false
                                                                    , "charset"                 => "utf8"
                                                                )
                                                                , "user_groups"                 => array(
                                                                    "name"                      => "access_users_groups"
                                                                    , "alias"                   => "user_groups"
                                                                    , "engine"                  => "InnoDB"
                                                                    , "crypt"                   => false
                                                                    , "pairing"                 => false
                                                                    , "transfert"               => false
                                                                    , "charset"                 => "utf8"
                                                                )
                                                                , "devices"                     => array(
                                                                    "name"                      => "access_devices"
                                                                    , "alias"                   => "device"
                                                                    , "engine"                  => "InnoDB"
                                                                    , "crypt"                   => false
                                                                    , "pairing"                 => false
                                                                    , "transfert"               => false
                                                                    , "charset"                 => "utf8"
                                                                )
                                                                , "tokens"                      => array(
                                                                    "name"                      => "access_tokens"
                                                                    , "alias"                   => "token"
                                                                    , "engine"                  => "InnoDB"
                                                                    , "crypt"                   => false
                                                                    , "pairing"                 => false
                                                                    , "transfert"               => false
                                                                    , "charset"                 => "utf8"
                                                                )
                                                            );
    private static $alias                                   = array(
                                                                /*
                                                                "users"                         => array(
                                                                    "ID_languages"              => "ID_lang"
                                                                    , "ID_domains"              => "ID_domain"
                                                                    , "primary_gid"             => "acl"
                                                                    , "expiration"              => "expire"
                                                                    , "activation_code"         => "SID"
                                                                    , "lastlogin"               => "last_login"
                                                                )
                                                                , "groups"                      => array(
                                                                    "gid"                       => "ID"
                                                                )
                                                                */
                                                            );

    /**
     * anagraphAccess constructor.
     * @param $anagraph
     */
    public function __construct($anagraph)
	{
		//$this->anagraph                                     = $anagraph;
        $anagraph->setConfig($this->connectors, $this->services, $this::TYPE);
	}

    /**
     * @param $type
     * @return array
     */
    public static function getStruct($type) {
        return array(
            "struct"                                        => self::$struct[$type]
            , "indexes"                                     => self::$indexes[$type]
            , "relationship"                                => self::$relationship[$type]
            , "table"                                       => self::$tables[$type]
            , "alias"                                       => self::$alias[$type]
            , "connectors"                                  => false
            , "mainTable"                                   => self::MAIN_TABLE
        );
    }

    /**
     * @param $anagraph
     * @return array
     */
    public static function getConfig($anagraph, $services) {
        $res                                                = null;
        $connectors                                         = self::$connectors;

        $res                                                = array_fill_keys(array_keys($services), null);

        $anagraph->setConfig($connectors, $res, self::TYPE);

        return $res;
    }

}

