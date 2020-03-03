import {Injectable} from '@angular/core';
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, switchMap} from 'rxjs/operators';
import {AuthService} from './auth.service';

@Injectable({
    providedIn: 'root'
})
export class RefreshTokenInterceptorService implements HttpInterceptor {

    constructor(private authService: AuthService) {
    }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

        return next.handle(req).pipe(catchError((error) => {

            if (error.status !== 401) {
                return throwError(error);
            }

            return this.handle(req, next);
        }));
    }

    async handle(req: HttpRequest<any>, next: HttpHandler) {

        const refresh = await this.authService.refreshToken();

        return refresh.pipe(switchMap(() => {
            return next.handle(req);
        })).toPromise();
    }
}
