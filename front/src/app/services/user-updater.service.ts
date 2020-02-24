import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {UserInterface} from '../interfaces/user-interface';

@Injectable({
    providedIn: 'root'
})
export class UserUpdaterService {

    readonly httpOptions;

    constructor(private http: HttpClient) {
        this.httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json'
            })
        };
    }

    create(user: UserInterface) {

        return this.http.post('http://localhost/api/register', user, this.httpOptions);
    }
}
