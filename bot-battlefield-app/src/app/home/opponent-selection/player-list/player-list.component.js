import { Component } from "../../../../component";
import { DialogComponent } from "../../../shared/dialog.component";
import { PlayerLocalService } from "../../../../shared/services/player-local.service";
import { PlayerSocketService } from "../../../../shared/services/player-socket.service";
import html from './player-list.component.html';

/**
 * @type {PlayerListComponent}
 */
export class PlayerListComponent extends Component {

    /**
     * @constructor
     */
    constructor(onPlay, onOpponent) {
        super("player-list", html);
        this.dialog = new DialogComponent();
        this.components.push(this.dialog);
        this.player;
        this.onPlay = onPlay
        this.onOpponent = onOpponent
    }

    /**
     * @returns {void}
     */
    display() {
        super.display();
        this.dialog.show();
        PlayerLocalService.read()
            .then((player) => {
                this.player = player;
                this.dialog.close();
                PlayerSocketService.onlisten(
                    (data) => data.opponent
                        ? this.onOpponent(data.opponent)
                        : this.update(data.players)
                )
                    .then(() => PlayerSocketService.send(player))
                    .catch((error) => this.onError(error));
            })
            .catch((error) => this.onError(error));
    }


    /**
     * @param {Array} players 
     */
    update(players) {
        for (const player of players) {
            if (this.player.id !== player.id
                && !PlayerSocketService.getPlayers().find(
                    (value) => player.id === value.id
                )) {
                this.add(player);
            }
        }
        for (const player of PlayerSocketService.getPlayers()) {
            if (this.player.id !== player.id
                && !players.find(
                    (value) => player.id === value.id
                )) {
                this.remove(player);
            }
        }
    }

    /**
     * @param {Player} player 
     */
    add(player) {
        const list = window.document.querySelector("player-list .mdl-list");
        const playerItem = window.document.createElement("li");
        const playerSpan = window.document.createElement("span");
        const playerI = window.document.createElement("i");
        playerItem.addEventListener("click", () => this.onSelect(player));
        playerItem.className = "mdl-list__item";
        playerItem.id = `player-${player.id}`;
        playerSpan.className = "mdl-list__item-primary-content";
        playerI.className = "material-icons mdl-list__item-icon";
        list
            .appendChild(playerItem)
            .appendChild(playerSpan)
            .appendChild(playerI)
            .appendChild(window.document.createTextNode("person"));
        playerSpan.appendChild(window.document.createTextNode(player.name));
    }

    /**
     * @param {Player} player 
     */
    remove(player) {
        const playerItem = window.document.querySelector(`#player-${player.id}`);
        playerItem.parentNode.removeChild(playerItem);
    }

    /**
     * @param {Player} player 
     */
    onSelect(player) {
        const selected = window.document.querySelector(`player-list ul .selected`);
        const item = window.document.querySelector(`#player-${player.id}`);
        const play = window.document.querySelector(`player-list .ePlay`);
        if (selected && item !== selected) {
            selected.className = selected.className.replace(` selected`, "");
        }
        if (-1 < item.className.search("selected")) {
            play.disabled = "disabled";
            item.className = item.className.replace(` selected`, "");
            play.onclick = null;
            return;
        }
        play.removeAttribute("disabled");
        item.className += ` selected`;
        play.onclick = () => this.onPlay(player);
    }
    
    /**
     * @param {String} error 
     */
    onError(error) {
        this.dialog.setTitle(error);
        this.dialog.addCloseButton("Close");
    }

}
