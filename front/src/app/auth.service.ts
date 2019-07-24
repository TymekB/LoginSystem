import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {BehaviorSubject, Observable} from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class AuthService {

    private authToken: string;
    private user: object;
    private isUserLogged: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);

    constructor(private http: HttpClient) {
    }

    authenticateUser(username: string, password: string): Observable<any> {

        const httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json'
            })
        };

        const user = {username, password};

        return this.http.post('http://localhost/api/user/verify', user, httpOptions);
    }

    storeUserData(token: string, user: object) {

        this.authToken = token;
        this.user = user;
        this.isUserLogged.next(true);

        localStorage.setItem('id_token', token);
        localStorage.setItem('user', JSON.stringify(user));
    }

    logout() {
        this.authToken = null;
        this.user = null;
        this.isUserLogged.next(false);
        localStorage.clear();
    }

    getUser() {
        return this.user;
    }

    getIsUserLogged() {
        return this.isUserLogged;
    }
}
