import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {User} from '../models/user';
import {UniqueUsernameValidator} from '../validator/uniqueUsername.validator';
import {UserRepositoryService} from '../services/user-repository.service';
import {UniqueEmailValidator} from '../validator/uniqueEmail.validator';
import {UserUpdaterService} from '../services/user-updater.service';
import {Router} from '@angular/router';
import {FlashMessagesService} from 'angular2-flash-messages';

@Component({
    selector: 'app-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

    registerForm: FormGroup;

    constructor(private userRepository: UserRepositoryService, private updater: UserUpdaterService,
                private router: Router, private flashMessage: FlashMessagesService) {

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

        if (this.registerForm.valid) {
            const user = new User(this.username.value, this.password.value, this.email.value);

            this.updater.create(user).subscribe((data: any) => {
                if (data.code === 200) {
                    this.router.navigate(['login']);
                    this.flashMessage.show(data.message, {cssClass: 'alert-success', timeout: 5000});
                }
            }, (error: any) => {
                this.flashMessage.show('Error occured. Please try again later',
                    {cssClass: 'alert-danger', timeout: 5000});
            });
        }
    }

    get username() {
        return this.registerForm.get('username');
    }

    get email() {
        return this.registerForm.get('email');
    }

    get password() {
        return this.registerForm.get('password');
    }

    get repeatPassword() {
        return this.registerForm.get('repeatPassword');
    }
}
