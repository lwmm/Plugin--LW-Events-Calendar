<?php

/**
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_events_calendar
 */

namespace LwEventsCalendar\Views;

class Teaser
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Das Fragenlisten-Template wird gerendert und zurueckgegeben.
     * 
     * @return string
     */
    public function render($array, $plugindata)
    {
        #print_r($plugindata);diE();
        $view = new \lw_view(dirname(__FILE__) . '/Templates/TeaserList.phtml');
        $view->jqueryMin = $this->config["url"]["media"] . "jquery/jquery.min.js";
        $view->fontsMinCSS = $this->config["url"]["media"] . "js/yui-calendar/css/fonts-min.css";
        $view->calendarCSS = $this->config["url"]["media"] . "js/yui-calendar/css/calendar.css";
        $view->yahoodom = $this->config["url"]["media"] . "js/yui-calendar/js/yahoo-dom-event.js";
        $view->calendarJS = $this->config["url"]["media"] . "js/yui-calendar/js/calendar-min.js";
        
        $view->calelements = $array;
        $view->data = $this->prepareArray($array, $plugindata["teaserelements"]);;
        $view->calendar = $plugindata["calendar"];
        $view->lang = $plugindata["language"];
        
        $baseUrl = \lw_page::getInstance($plugindata["targetid"])->getUrl();
        $view->baseUrl = $baseUrl;
        $view->baseUrlWithoutIndex = substr($baseUrl, 0, strpos($baseUrl, "index=") + strlen("index="));

        return $view->render();
    }

    private function prepareArray($array, $amount)
    {
        $temp = array();
        $i = 0;

        foreach ($array as $entry) {
            if ($i < $amount) {
                $temp[$i] = $entry;
            }
            $i++;
        }
        
        return $temp;
    }

}