import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {BehaviorSubject, Observable} from 'rxjs';
import {tokenNotExpired} from 'angular2-jwt';

@Injectable({
    providedIn: 'root'
})
export class AuthService {

    private authToken: string;
    private user: object;

    constructor(private http: HttpClient) {
    }

    authenticateUser(user: UserInterface): Observable<any> {

        const httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json'
            })
        };

        return this.http.post('http://localhost/api/user/verify', user, httpOptions);
    }

    storeUserData(token: string, user: object) {

        this.authToken = token;
        this.user = user;

        localStorage.setItem('id_token', token);
        localStorage.setItem('user', JSON.stringify(user));
    }

    logout() {
        this.authToken = null;
        this.user = null;
        localStorage.clear();
    }

    loggedIn() {
        return tokenNotExpired('id_token');
    }

    getUser() {

        const user = JSON.parse(localStorage.getItem('user'));

        if (user) {
            this.user = user;
        }

        return this.user;
    }
}


