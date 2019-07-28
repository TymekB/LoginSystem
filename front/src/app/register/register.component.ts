import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {User} from '../user';
import {UniqueUsernameValidator} from '../validator/uniqueUsername.validator';
import {UserRepositoryService} from '../user-repository.service';
import {map} from 'rxjs/operators';
import {UniqueEmailValidator} from '../validator/uniqueEmail.validator';

@Component({
    selector: 'app-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

    registerForm: FormGroup;
    user: User = new User();

    constructor(private userRepository: UserRepositoryService) {

        this.registerForm = new FormGroup({
            username: new FormControl(null,
                [
                    Validators.required,
                    Validators.minLength(4),
                    Validators.maxLength(20),
                    Validators.pattern(/^[a-z0-9]+$/i)
                ], [UniqueUsernameValidator.createValidator(this.userRepository)]),
            email: new FormControl(null,
                [
                    Validators.required,
                    Validators.email
                ], [UniqueEmailValidator.createValidator(this.userRepository)]),
            password: new FormControl(null,
                [
                    Validators.required,
                    Validators.minLength(8),
                    Validators.maxLength(30),
            ]),
            repeatPassword: new FormControl(null, [Validators.required])
        });

    }

    ngOnInit() {

    }

    onSubmit() {
        console.log(this.registerForm.value);
        console.log(this.registerForm.valid);
    }

    get username() { return this.registerForm.get('username'); }
    get email() { return this.registerForm.get('email'); }
    get password() { return this.registerForm.get('password'); }
    get repeatPassword() { return this.registerForm.get('repeatPassword'); }
}
