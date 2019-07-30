import { botBattlefieldApi } from '../../../resources/bot-battlefield.api';

/**
 * @type {PlayerApiService}
 */
export class PlayerApiService {

    /**
     * @constructor
     */
    constructor() { }

    /**
     * @param {PlayerModel} player 
     * @returns {Promise}
     */
    static read(player) {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () =>
                4 !== xhr.readyState ? null : (200 === xhr.status
                    ? resolve(JSON.parse(xhr.response).players)
                    : reject("Can not process entity"));
            xhr.open("GET", botBattlefieldApi.url + botBattlefieldApi.endpoints.players);
            xhr.setRequestHeader(
                "Authorization",
                `Basic ${window.btoa(`${player.name}:${player.token}`)}`
            );
            xhr.send();
        });
    }

    /**
     * @param {String} name
     * @returns {Promise}
     */
    static create(name) {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () =>
                4 !== xhr.readyState ? null : (201 === xhr.status
                    ? resolve(JSON.parse(xhr.response).player)
                    : reject("Player already exists"));
            xhr.open("POST", botBattlefieldApi.url + botBattlefieldApi.endpoints.players);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(`name=${window.encodeURI(name)}`);
        });
    }

}
