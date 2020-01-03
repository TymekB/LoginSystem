import {Component, OnInit} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {HttpClient, HttpHeaders} from '@angular/common/http';

@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

    constructor(private auth: AuthService, private http: HttpClient) {
    }

    ngOnInit() {

        this.http.get('http://localhost/api/test', {withCredentials: true})
            .subscribe(response => console.log(response));
    }

}
