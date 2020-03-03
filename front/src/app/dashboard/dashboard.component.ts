import {Component, OnInit} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {HttpClient} from '@angular/common/http';

@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

    constructor(private auth: AuthService, private http: HttpClient) {
    }

    ngOnInit() {
        this.http.get('/api/test')
            .subscribe(response => console.log(response), error => console.log(error));

        this.http.get('/api/test')
            .subscribe(response => console.log(response), error => console.log(error));
    }

}
