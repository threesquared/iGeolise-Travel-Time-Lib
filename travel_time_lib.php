<?php

/*
 * iGeolise Travel Time Library
 * Used to interact with the iGeolise Travel Time API
 * http://www.igeolise.com/travel-time/
 *
 * Primitive types:
 * Int                 - a regular integer, e.g. 5, -1 or 19
 * Double              - a regular double, e.g. 2.45, -1.2 or 0.245
 * Boolean             - JSON boolean, e.g. true or false.
 *
 * Custom Types:
 * DateTime            - ISO formatted date, e.g. "2012-11-26T18:14:52.892+02:00"
 * DegreeCoordsV1      - coordinates in the WGS 84 format, in degrees, e.g. {"lat": Double, "lng": Double}, e.g. {"lat": 12.3, "lng": -3.22}
 * DegreeCoordsV2      - coordinates in the WGS 84 format, in degrees, e.g. [lat (Double), lng (Double)], e.g. [12.3, -3.22]
 * PointWithId         - point with id value attached, e.g. {"id": String, "lat": Double, "lng": Double}
 * TransportationMode  - string with one of following values: "walking_train", "walking", "walking_bus", "driving" or "public_transport"
 * EdgeType            - describes type of the edge. String with one of following values: "bus", "plane", "cable_car", "walk", "car", "ship" or "train"
 * Accuracy            - String with one of following values: "exact" or "approx"
 * Properties          - A Hash with one or more properties that you requested. E.g. {"time": Int, "distance": Int} or {"distance": Int}
 * 
 * http://api.traveltimeapp.com/
 *
 * @author Ben Speakman <ben@cyber-duck.co.uk>
 * 
 */
class Travel_time_lib {

    /**
     * @param  String               id            iGeolise API ID
     * @param  String               key           iGeolise API Key
     * @param  Boolean              debug         Debug info on/off
     */
    public function __construct($id, $key, $debug = FALSE)
    {
        $this->id    = $id;
        $this->key   = $key;
        $this->debug = $debug;
        $this->url   = 'http://api.traveltimeapp.com/v2/';
    }

    /**
     * Time Filter
     * Used to rank points (quickest time first) and will include the time to each point.
     * 
     * @param  Int                   travel_time   Travel Time in Seconds
     * @param  DegreeCoordsV2        origin        
     * @param  PointWithId           points        Points that you need travel time calculated for.
     * @param  TransportationMode    modes          
     * @param  DateTime              start_time    Specifies when do we start our search.
     * @param  Properties            properties    This specifies which data properties you want to know about the point.
     * @return Array
     */
    public function time_filter($params = array())
    {

        return $this->post_request($this->url."time_filter", $params);

    }

    /**
     * Time Map
     * Used to generate a map that defines the area you can reach within the given time and mode of transport.
     * 
     * @param  Int                   travel_time   Travel Time in Seconds
     * @param  DegreeCoordsV2        origin        
     * @param  TransportationMode    mode          
     * @param  Boolean               smooth        Should the shape be smoothed?  
     * @param  DateTime              start_time    Specifies when do we start our search. 
     * @return Array 
     */
    public function time_map($params = array())
    {

        return $this->post_request($this->url."time_map", $params);
        
    }

    /**
     * Routes
     * Used to get the route for each point
     * 
     * @param  Int                   travel_time   Travel Time in Seconds
     * @param  DegreeCoordsV2        origin        
     * @param  PointWithId           points        Points that you need travel time calculated for.
     * @param  TransportationMode    mode          
     * @param  DateTime              start_time    When do we start our search?
     * @return Array 
     */
    public function routes($params = array())
    {

        return $this->post_request($this->url."routes", $params);
        
    }

    /**
     * Geocode Postcodes
     * Used to get a very simple UK PostCode to Lat / Lng
     * 
     * @param  Array                  postcodes   List of postcodes
     * @return Array 
     */
    public function geocode_postcodes($params = array())
    {

        return $this->post_request($this->url."postcodes/geocode", array('postcodes' => $params));
        
    }

    /**
     * Post Request
     * Used to send the request to the API
     * 
     * @param  String                 url          Url of the API endpoint
     * @param  Array                  request      Array of parameters 
     * @return Array 
     */
    private function post_request($url, $request = array())
    {

        $request['app_id']  = $this->id;
        $request['app_key'] = $this->key;
                                                        
        $ch = curl_init($url);  

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                     
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));                                                                                                                   
         
        $result['results'] = json_decode(curl_exec($ch));

        // Error handling
        if (!$result['results']) {
            $result['error']   = curl_error($ch);
        } else if (isset($result['results']->code)){
            $result['error']   = $result['results']->details;
            $result['results'] = null;
        }

        // Debug info
        if ($this->debug == TRUE) {
            $info = curl_getinfo($ch);
            $result['time'] = $info['total_time'];
            $result['code'] = $info['http_code'];
            $result['request'] = json_encode($request);
        }

        return $result;

    }

}