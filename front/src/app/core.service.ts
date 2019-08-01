import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable, Subject, ReplaySubject } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';

import {ConstantsGlobalService} from './constants/constants-global.service';

@Injectable({
  providedIn: 'root'
})
export class CoreService {
    public options: object;
    public GC: ConstantsGlobalService;

    constructor(protected http: HttpClient,
                protected router: Router) {
        this.GC = new ConstantsGlobalService();
    }

    private setParamsOptions(object){
        this.options['params'] = new HttpParams({
            fromObject: object
        });
    }

    private getOptions(newHeader?){
        let headers = new HttpHeaders({'Accept': 'application/json'});
        if(this.getToken()){
            headers = headers.set('Authorization', 'Bearer ' + this.getToken());
        }
        if(newHeader && newHeader instanceof Array){
            newHeader.forEach(obj => {
                if(obj) {
                    headers = headers.set(obj.header, obj.value);
                }
            });
        }else{
            headers = headers.set('Content-Type', 'application/json');
        }

        return this.options = { headers: headers, params: {} };
    }

    public post(url, data, headers?): Observable<any> {
        return this.http
            .post(`${this.GC.API_ENDPOINT}/${url}`, data, this.getOptions(headers));
    }

    public remove(url): Observable<any> {
        return this.http
            .delete(`${this.GC.API_ENDPOINT}/${url}`, this.options);
    }

    public get(url, object?): Observable<any> {
        this.getOptions();
        if(object) {
            this.setParamsOptions(object);
        }

        return this.http
            .get(`${this.GC.API_ENDPOINT}/${url}`, this.options);
    }

    public update(url, object): Observable<any> {
        this.getOptions();
        this.setParamsOptions(object);

        return this.http
            .put(`${this.GC.API_ENDPOINT}/${url}`, this.options);
    }

    public getToken(){
        const all = JSON.parse(localStorage.getItem('currentUser'));
        if ( all && all.access_token ) {
            return all.access_token;
        }
    }
}
