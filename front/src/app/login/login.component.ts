import {Component, OnInit} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {Router} from '@angular/router';
import {FlashMessagesService} from 'angular2-flash-messages';
import {User} from '../models/user';
import {BehaviorSubject, interval, of} from "rxjs";
import {switchMap, take} from "rxjs/operators";

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    user: User = new User();
    private error = false;

    constructor(private auth: AuthService, private flashMessage: FlashMessagesService, private router: Router) {
    }

    ngOnInit() {

    }

    onSubmit() {


        this.auth.authenticateUser(this.user).subscribe((response: any) => {

            console.log(response);

            this.error = false;

            this.auth.setUser(response.user);
            this.router.navigate(['dashboard']);

        }, (error) => {

            console.log(error);

            this.error = true;
        });
    }

}
