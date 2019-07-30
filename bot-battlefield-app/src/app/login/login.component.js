import { Component } from "../../component";
import { PlayerApiService } from "../../shared/services/player-api.service";
import { PlayerLocalService } from '../../shared/services/player-local.service';
import { Router } from '../../route/router';
import { DialogComponent } from '../shared/dialog.component';
import html from './login.component.html';

/**
 * @type {LoginComponent}
 */
export class LoginComponent extends Component {

    /**
     * @constructor
     */
    constructor() {
        super(`login`, html);
        this.dialog = new DialogComponent();
        this.regex = "^[a-z@-Z\\d\\xC0-\\xFF_-]{3,16}$";
        this.nickname;
        this.components.push(this.dialog);
    }

    /**
     * @returns {void}
     */
    display() {
        super.display();
        PlayerLocalService.read()
            .then((player) => null !== player ? Router.navigate("/home") : this.run())
            .catch((error) => this.run());
    }

    /**
     * @returns {void}
     */
    run() {
        this.nickname = window.document.querySelector("login #nickname");
        this.nickname.pattern = this.regex;
        this.nickname.focus();
        window.componentHandler.upgradeDom();
        window.document.querySelector("login .eStart")
            .addEventListener("click", () => this.onStart());
    }

    /**
     * @returns {void}
     */
    onStart() {
        if (!(new window.RegExp(this.regex)).test(this.nickname.value)) {
            return this.nickname.focus();
        }
        this.dialog.show();
        PlayerApiService.create(this.nickname.value)
            .then((player) => this.onCreateLoad(player))
            .catch((error) => this.onError(error))
    }

    /**
     * @param {Player} player
     */
    onCreateLoad(player) {
        this.dialog.setImage();
        this.dialog.validRegister();

        PlayerLocalService.create(player)
            .then(() => this.dialog.addCloseButton("Close").addEventListener("click", () => {
                Router.navigate("/home")
            }))
                .catch((error) => this.onError(error));
    }

    /**
     * @param {String} error
     */
    onError(error) {
        this.dialog.setTitle(error);
        this.dialog.addCloseButton();
    }

}
