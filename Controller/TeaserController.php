<?php

/**
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_events_calendar
 */

namespace LwEventsCalendar\Controller;

class TeaserController
{

    protected $response;
    protected $config;

    /**
     * @param object $response
     */
    public function __construct($response, $config)
    {
        $this->response = $response;
        $this->config = $config;
    }

    /**
     * Informations will be collected that the template can be rendered.
     * 
     * @return array
     */
    public function execute()
    {
        $plugindata = $this->response->getDataByKey("plugindata");
        $queryHandler = new \LwEventsCalendar\Model\DataHandler\QueryHandler($this->response->getDbObject());
        
        $array = $queryHandler->getAllActualElementsForCalendar($plugindata["targetid"]);
        
        $view = new \LwEventsCalendar\Views\Teaser($this->config);        
        $this->response->setOutputByKey("lw_events_calendar" , $view->render($array, $plugindata));
    }

}