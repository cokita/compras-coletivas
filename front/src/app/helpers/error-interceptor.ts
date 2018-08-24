import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { MatSnackBar } from '@angular/material';


import { LoginService } from '../user/login/login.service';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
    constructor(private loginService: LoginService, private _router: Router, public snackBar: MatSnackBar) {
        console.log('aaaaaaaaaaa');
    }

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        return next.handle(request).pipe(catchError(err => {

            this.snackBar.open(err.error.message, null, {
                duration: 2000,
                verticalPosition: 'bottom',
                horizontalPosition:'right'
            });
            if (err.status === 401) {
                if(this._router.url.indexOf('/login') === -1) {
                    // auto logout if 401 response returned from api
                    // this.loginService.logout();
                    // location.reload(true);
                }
            }

            const error = err.error.message || err.statusText;
            return throwError(error);
        }))
    }
}
