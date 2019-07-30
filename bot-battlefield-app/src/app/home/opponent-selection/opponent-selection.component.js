import { PlayerListComponent } from "./player-list/player-list.component";
import { Opponent } from "../../../shared/models/opponent.model";
import { Component } from "../../../component";
import html from './opponent-selection.component.html';
import { PlayerSocketService } from "../../../shared/services/player-socket.service";
import { Router } from "../../../route/router";

export class OpponentSelectionComponent extends Component {

    /**
     * @constructor
     */
    constructor() {
        super("opponent", html);
        this.components.push(new PlayerListComponent(this.onPlay, this.onOpponent))
    }

    /**
     * @param {Player} player 
     */
    onPlay(player) {
        const opponent = new Opponent;
        opponent.playerOne = this.player;
        opponent.playerTwo = player;
        PlayerSocketService.send(opponent);
        this.dialog.show();
        this.dialog.setTitle("Waiting player");
        this.dialog.setImage();
        this.dialog.addCloseButton("Cancel").addEventListener("click", () => {
            opponent.playerOne = null;
            PlayerSocketService.send(opponent);
        });
    }

        /**
     * @param {Oppoenent} opponent 
     */
    onOpponent(opponent) {
        console.log(opponent);
        if (null === opponent.playerOne || null === opponent.playerTwo) {
            this.dialog.close();
            this.dialog.show();
            this.dialog.setTitle(`Opponent cancel the game`);
            this.dialog.setImage("https://i.imgur.com/at0jWbJ.gif","happy anime girl")
            this.dialog.addCloseButton("Close");
        } else if (null === opponent.game){
            this.dialog.show();
            this.dialog.setTitle(`${opponent.playerOne.name} invite you`);
            this.dialog.setImage('https://i.imgur.com/2ThlbUH.gif', "angry anime girl")
            this.dialog.addCloseButton("fight", "accent").addEventListener("click", () => {
                PlayerSocketService.send(opponent);
                Router.navigate("/game")
            });
            this.dialog.addCloseButton("Run").addEventListener("click", () => {
                opponent.playerTwo = null;
                PlayerSocketService.send(opponent);
            });
        } else {
            Router.navigate("/game")
        }
    }
}
