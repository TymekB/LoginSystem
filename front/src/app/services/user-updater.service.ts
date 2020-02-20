import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';

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

    create(user: UserInterface, recaptcha: string) {

        const data = {...user, recaptcha};

        return this.http.post('http://localhost/api/register', user, this.httpOptions);
    }
}
