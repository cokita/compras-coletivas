import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import {RequestOptions} from '@angular/http';
import { Router } from '@angular/router';
import { Observable, Subject, ReplaySubject } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';

import {ConstantsGlobalService} from "./constants/constants-global.service";


@Injectable({
  providedIn: 'root'
})
export class CoreService {
    public headers: HttpHeaders;
    public options: Object;
    public GC: ConstantsGlobalService;

    constructor(protected http: HttpClient,
                protected router: Router) {

        this.GC = new ConstantsGlobalService();
        let headers = new HttpHeaders();
        headers = headers.append('Content-Type', 'application/json');

        this.options = { headers: headers, params: {} };
    }

    public create(data): Observable<any> {
        return this.http
            .post(this.GC.API_ENDPOINT, data, this.options);
    }

    public remove(id): Observable<any> {
        return this.http
            .delete(`${this.GC.API_ENDPOINT}/${id}`, this.options);
    }

    public get(id, object?): Observable<any> {
        if(object) {
            this.options['params'] = new HttpParams({
                fromObject: object
            });
        }

        return this.http
            .get(`${this.GC.API_ENDPOINT}/${id}`, this.options);
    }

    public update(id, object): Observable<any> {
        this.options['params'] = new HttpParams({
            fromObject: object
        });
        return this.http
            .put(`${this.GC.API_ENDPOINT}/${id}`, this.options);
    }
}
