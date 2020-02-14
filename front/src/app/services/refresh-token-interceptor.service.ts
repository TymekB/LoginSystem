import {Injectable} from '@angular/core';
import {HttpClient, HttpEvent, HttpHandler, HttpHeaders, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {BehaviorSubject, Observable, of, throwError} from 'rxjs';
import {catchError, delay, filter, map, retry, switchMap, take} from 'rxjs/operators';
import {AuthService} from './auth.service';


@Injectable({
    providedIn: 'root'
})
export class RefreshTokenInterceptorService implements HttpInterceptor {

    private isRefreshing = false;
    private subject = new BehaviorSubject(false);

    constructor(private http: HttpClient, private authService: AuthService) {
    }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

        return next.handle(req).pipe(catchError((error): Observable<any> => {

            if (error.status !== 401) {
                return throwError(error);
            }

            if (!this.isRefreshing) {
                this.isRefreshing = true;

                return this.authService.refreshToken().pipe(switchMap((result) => {
                    this.isRefreshing = false;
                    this.subject.next(true);

                    return next.handle(req);
                }));
            } else {
                return this.subject.pipe(
                    filter(value => value !== false),
                    switchMap(() => {
                       return next.handle(req);
                    })
                );
            }
        }));
    }
}
