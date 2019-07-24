import { Injectable } from '@angular/core';
import {HttpRequest, HttpHandler, HttpEvent, HttpInterceptor, HttpErrorResponse} from '@angular/common/http';
import { Observable,throwError  } from 'rxjs';
import { finalize, delay, catchError } from 'rxjs/operators';
import {NgxSpinnerService} from "ngx-spinner";


@Injectable()
export class HttpRequestInterceptor implements HttpInterceptor {

    constructor(private spinner: NgxSpinnerService) { }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        this.spinner.show();
        return next.handle(req).pipe(
            //delay(1000),
            finalize(() => this.spinner.hide()),
            catchError((error: HttpErrorResponse) => {
                this.spinner.hide();
                return throwError(error);
            })
        );
    }
}
