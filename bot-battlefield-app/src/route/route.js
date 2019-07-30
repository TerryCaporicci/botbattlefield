import { Component } from "../component";

export class Route {

    /**
     * @param {String} url 
     * @param {Component} component 
     * @param {Array} parameters 
     */
    constructor(url, component, parameters) {
        this.url = url;
        this.component = component;
        this.parameters = parameters;
    }

}
