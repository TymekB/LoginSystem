import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class UserRepositoryService {

    constructor(private http: HttpClient) {
    }

    findByUsername(username: string) {

        return this.http.get('http://localhost/api/user/find/username/' + username);
    }

    findByEmail(email: string) {

        return this.http.get('http://localhost/api/user/find/email/' + email);
    }

}
