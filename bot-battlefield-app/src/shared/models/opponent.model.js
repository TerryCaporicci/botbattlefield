import { Player } from "./player.model";
import { Game } from "./game.model";

/**
 * @type {Opponent}
 */
export class Opponent {

    /**
     * @constructor
     */
    constructor() {

        /**
         * @type {Number}
         */
        this.id = null;
        
        /**
         * @type {Player}
         */
        this.playerOne = null;

        /**
         * @type {Player}
         */
        this.playerTwo = null;

        /**
         * @type {Game}
         */
        this.game = null;

    }

}
