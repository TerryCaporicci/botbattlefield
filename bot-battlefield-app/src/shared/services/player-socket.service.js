import { botBattlefieldWs } from "../../../resources/bot-battlefield.ws";

/**
 * @var {WebSocket}
 */
let server;

/**
 * @var {Player[]}
 */
let players = [];

/**
 * @type {PlayerSocketService}
 */
export class PlayerSocketService {

    /**
     * @constructor
     */
    constructor() { }

    /**
     * @returns {Player[]}
     */
    static getPlayers() {
        return players;
    }

    /**
     * @param {Object} data 
     */
    static send(data) {
        server.send(JSON.stringify(data));
    }

    /**
     * 
     * @param {Function} callback 
     * @returns {Promise}
     */
    static onlisten(callback) {
        return new Promise((resolve, reject) => {
            server = new WebSocket(
                botBattlefieldWs.url + botBattlefieldWs.endpoints.players
            );
            server.onopen = () => resolve(server);
            server.onmessage = (event) => {
                const data = JSON.parse(event.data);
                callback(data);
                if (data.players) {
                    return players = data.players;
                }
            };
            server.onerror = (event) => reject(event);
        })
    }

}
