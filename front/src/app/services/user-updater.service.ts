import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class UserUpdaterService {

    constructor(private http: HttpClient) {
    }

    create(username: string, password: string, email: string) {
        const httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json'
            })
        };

        const user = {username, password, email};

        this.http.post('http://localhost/api/register', user, httpOptions).subscribe((data) => {
            console.log(data);
        });
    }
}
