import { Route } from "./route";

const routes = [];

routes.push = function () {
        if(!(arguments[0] instanceof Route)) {
            throw new TypeError(
                `Pushed elements of "routes" must be instaceof "Routes" at index ${routes.length}`
            )
        }
    }
export class Router {

    
    static add(url, component, params) {
        routes.push(new Route(url, component, params));
        return Router;
    }

    static navigate(url, parameters) {
        for (let route of routes) {
            if (route.url === url) {
                const element = window.document.querySelector("router");
                const existingComponent = window.document.querySelector("router *");
                if (existingComponent) {
                    element.removeChild(existingComponent);
                }
                const component = window.document.createElement(route.component.balise);
                element.appendChild(component);
                route.component.display();
                return true;
            }
        }
        return false;
    }

    static get() {
        return routes;
    }

}
