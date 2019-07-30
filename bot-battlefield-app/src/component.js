export class Component {

    constructor(balise, html) {
        this.html = html;
        this.balise = balise;
        this.components = [];
        this.components.push = (component) => {            
            if (!(component instanceof Component)) {
                throw new Error(
                `Pushed element of "components" must be instanceof "component" `
                 + `at index ${this.components.length}` 
                )
            }
            this.components[this.components.length] = component;
            return this.components.length
        }
    }

    display() {
        const element = window.document.querySelector(this.balise);
        element.innerHTML = this.html;
        for (const component of this.components) {
            component.display();
        }
    }

}
