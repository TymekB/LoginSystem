import {Component, OnInit} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {catchError, delay, switchMap} from "rxjs/operators";
import {BehaviorSubject, of, throwError} from "rxjs";


@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

    constructor(private auth: AuthService, private http: HttpClient) {
    }

    ngOnInit() {

        this.http.get('http://localhost/api/test')
            .subscribe(response => console.log(response), error => console.log(error));
    }

}
