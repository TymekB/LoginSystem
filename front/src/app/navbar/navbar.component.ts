import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../auth.service';

@Component({
    selector: 'app-navbar',
    templateUrl: './navbar.component.html',
    styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

    isUserLoggedIn: boolean;

    constructor(private authService: AuthService, private router: Router) {

        this.authService.getIsUserLogged().subscribe(value => {
            this.isUserLoggedIn = value;
            console.log('user logged: ' + value);
        });
    }

    ngOnInit() {
    }
}
