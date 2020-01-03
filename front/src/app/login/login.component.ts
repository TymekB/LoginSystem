import {Component, OnInit} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {Router} from '@angular/router';
import {FlashMessagesService} from 'angular2-flash-messages';
import {User} from '../models/user';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    user: User = new User();

    constructor(private auth: AuthService, private flashMessage: FlashMessagesService, private router: Router) {
    }

    ngOnInit() {
    }

    onSubmit() {

        this.auth.authenticateUser(this.user).subscribe((response: any) => {
            if (response.code === 200) {

                console.log(response);

                this.auth.setUser(response.data.user);
                this.router.navigate(['dashboard']);
            }
        }, () => {
            this.flashMessage.show('Wrong credentials',
                {cssClass: 'alert-danger', timeout: 5000}
            );
        });
    }

}
