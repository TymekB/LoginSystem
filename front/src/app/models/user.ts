import {UserInterface} from '../interfaces/user-interface';

export class User implements UserInterface {
    constructor(public username: string = null, public password: string = null, public email: string = null,
                public recaptcha: string = null) {
    }
}
