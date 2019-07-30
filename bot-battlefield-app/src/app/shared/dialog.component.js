import html from "./dialog.component.html"
import dialogPolyfill from 'dialog-polyfill'
import { Component } from "../../component";


let imageUrl;

export class DialogComponent extends Component {
    constructor() {
        super(`shared-dialog`, html);
        this.dialog;
    }
    display() {
        super.display();
        this.dialog = window.document.querySelector("dialog");
        dialogPolyfill.registerDialog(this.dialog)

        imageUrl = [
            "https://i.imgur.com/usu1HCx.gif",
            "https://i.imgur.com/8XVo2ey.gif",
            "https://media3.giphy.com/media/NrXKEx6OiUrio/giphy.gif",
            "https://i.redd.it/9uq2kkd3uid21.gif"
        ];
    }


    show() {
        this.display();
        this.dialog.showModal();
    }

    close() {
        this.dialog.close();
    }

    setTitle(title) {
        window.document.querySelector("dialog .mdl-dialog__title")
            .firstChild.nodeValue = title
    }
    setImage(image, alt) {
        if (!alt) {
        alt = "anime girl who spin these finger, it's really fun."
        }
        if (!image) {
        image = imageUrl[Math.floor(Math.random() * imageUrl.length)];
        }
        window.document.querySelector(".spinner").setAttribute("src", image)
        window.document.querySelector(".spinner").setAttribute("alt", alt)
    }

    removeImage() {
        window.document.querySelector(".spinner").setAttribute("src", "");
    }

    addCloseButton(text, style) {
        const divBtn = window.document.querySelector("div .mdl-dialog__actions");
        const Form = document.createElement("form");
        const btn = document.createElement("button");
        const txtButton = document.createTextNode(text);
        divBtn.appendChild(Form).setAttribute("method", "dialog");
        Form.appendChild(btn).setAttribute("type", "submite");
        btn.setAttribute("class", "mdl-button mdl-button--raised");
        if (style) {
            btn.setAttribute("class", `mdl-button mdl-button--raised mdl-button--${style}`)
        }
        btn.appendChild(txtButton);
        return btn;
    }

    validRegister() {
        this.removeImage();
        this.setImage("https://media.giphy.com/media/YWF1baNd94QO4/giphy.gif")
        this.setTitle("You are now registered, time to play")
    }
}