<?php

/**
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_events_calendar
 */
class lw_events_calendar extends lw_plugin
{

    protected $db;
    protected $response;
    protected $config;

    /**
     * For the functionality of this plugin is it necessary to include
     * the "Autoloader" and the instances of "in_auth" and "auth"
     * objects.
     */
    public function __construct()
    {
        parent::__construct();
        include_once(dirname(__FILE__) . '/Services/Autoloader.php');
        $autoloader = new \LwEventsCalendar\Services\Autoloader();
        $this->response = new \LwEventsCalendar\Services\Response();
    }

    /**
     * The HTML frontend output will be build for logged in user. Not logged in
     * user will be redirected to the login page. 
     * 
     * @return string
     */
    public function buildPageOutput()
    {    
        if (array_key_exists("teaserelements", $this->params) && array_key_exists("calendar", $this->params ) && array_key_exists("targetid", $this->params)) {
            if ($this->params["teaserelements"] < 1) {
                $plugindata["parameter"]["teaserelements"] = 1;
            }
            elseif ($this->params["teaserelements"] > 10) {
                $plugindata["parameter"]["teaserelements"] = 10;
            }
            else {
                $plugindata["parameter"]["teaserelements"] = $this->params["teaserelements"];
            }

            if (array_key_exists("language", $this->params)) {
                $plugindata["parameter"]["language"] = $this->params["language"];
            }
            else {
                $plugindata["parameter"]["language"] = "en";
            }
            if($this->params["calendar"] > 0) {
                $plugindata["parameter"]["calendar"] = 1;
            }else{
                $plugindata["parameter"]["calendar"] = 0;
            }
            
            $plugindata["parameter"]["targetid"] = $this->params["targetid"];
        }
        else {
            die("Plugin-Aufruf nicht korrekt! Bsp. : [PLUGIN:lw_events_calendar?teaserelements=3&language=de&calendar=1&targetid=22]");
        }        

        $response = new \LwEventsCalendar\Services\Response();
        $response->setDbObject($this->db);
        $response->setDataByKey("plugindata", $plugindata["parameter"]);

        $controller = new \LwEventsCalendar\Controller\TeaserController($response, $this->config);
        $controller->execute();

        return $response->getOutputByKey("lw_events_calendar");
    }

    /**
     * The HTML backend output will be build.
     * 
     * @return string
     */
    public function getOutput()
    {
        return "";
    }

    /**
     * Here will be set if the plugin-conetentbox is deleteable from a page.
     * 
     * @return boolean
     */
    function deleteEntry()
    {
        return true;
    }
}