import { Component } from "../../component";
import html from "../game/game.component.html"

export class GameComponent extends Component{
    constructor() {
        super(`game`, html);
    }
}