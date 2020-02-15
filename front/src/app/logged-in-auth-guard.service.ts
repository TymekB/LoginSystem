import {Injectable} from '@angular/core';
import {AuthService} from './services/auth.service';
import {CanActivate, Router} from '@angular/router';

@Injectable({
    providedIn: 'root'
})
export class LoggedInAuthGuardService implements CanActivate {

    constructor(private auth: AuthService, private router: Router) {
    }

    canActivate(): boolean {
        if (this.auth.isLoggedIn()) {
            this.router.navigate(['/dashboard']);

            return false;
        }

        return true;
    }


}
