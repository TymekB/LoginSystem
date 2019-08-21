import {Component, OnInit} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {Router} from '@angular/router';
import {FlashMessagesService} from 'angular2-flash-messages';
import {UserRepositoryService} from '../services/user-repository.service';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    username: string;
    password: string;

    constructor(private auth: AuthService, private flashMessage: FlashMessagesService, private router: Router) {
    }

    ngOnInit() {
    }

    onSubmit() {

        this.auth.authenticateUser(this.username, this.password).subscribe((data) => {

            console.log(data.success);

            if (data.success) {
                this.auth.storeUserData(data.token, data.user);
                this.router.navigate(['dashboard']);
            } else {
                this.flashMessage.show(data.message, {cssClass: 'alert-danger'});
            }
        });

    }

}
