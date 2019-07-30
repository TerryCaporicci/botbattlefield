import { Component } from "../component";
import { HomeComponent } from "./home/home.component";
import { LoginComponent } from "./login/login.component";
import { Router } from "../route/router";

import html from './app.component.html';
import { GameComponent } from "./game/game.component";

export class AppComponent extends Component {

    constructor() {
        super(`app`, html);
        Router
            .add("/login", new LoginComponent())
            .add("/game", new GameComponent())
            .add("/home", new HomeComponent());
    }

    display() {
        super.display();
        Router.navigate("/login");
    }

}
