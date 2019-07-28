import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class UserRepositoryService {

    constructor(private http: HttpClient) {
    }

    findByUsername(username: string) {

        return this.http.get('http://localhost/api/find/username/' + username);
    }

    findByEmail(email: string) {

        return this.http.get('http://localhost/api/find/email/' + email);
    }

}
