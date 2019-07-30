import { Component } from "../../../component";
import { PlayerLocalService } from "../../../shared/services/player-local.service";
import html from './menu.component.html';

export class MenuComponent extends Component {

    /**
     * @constructor
     */
    constructor() {
        super("menu", html);
    }

    /**
     * @returns {void}
     */
    display() {
        super.display();
        window.componentHandler.upgradeDom();
        PlayerLocalService.read()
            .then((player) => this.setPlayerTitle(player))
            .catch(() => { });
    }

    /**
     * @param {PlayerModel} player 
     */
    setPlayerTitle(player) {
        window.document
            .querySelector(".mdl-layout-title")
            .firstChild.nodeValue = player.name;
    }

}
