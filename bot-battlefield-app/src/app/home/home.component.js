import { MenuComponent } from "./menu/menu.component";
import { OpponentSelectionComponent } from "./opponent-selection/opponent-selection.component";
import { Component } from "../../component";
import { Router } from "../../route/router";
import { PlayerLocalService } from "../../shared/services/player-local.service";
import html from './home.component.html';

export class HomeComponent extends Component {

    /**
     * @constructor
     */
    constructor() {
        super(`home`, html);
        this.components.push(
            new MenuComponent(),
            new OpponentSelectionComponent()
        )
    }

    /**
     * @returns {void}
     */
    display() {
        super.display();
        PlayerLocalService.read().then(
            (player) => null === player ? Router.navigate("/login") : null
        );
    }

}
