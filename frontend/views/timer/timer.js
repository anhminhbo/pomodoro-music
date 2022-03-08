class timer {
    constructor(root) {
        root.innerHTML = Timer.getHTML();
        this.el = root.querySelector('.timer__part--minutes');
    }
