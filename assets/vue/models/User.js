

export default class User {
    constructor(id, email, active = false, online = false) {
        this.id = id;
        this.email = email;
        this.active = active;
        this.online = online;
    }
}
