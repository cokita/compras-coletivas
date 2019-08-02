import { Injectable } from '@angular/core';
import { map } from 'rxjs/operators';
import {CoreService} from "../../core.service";
import {HttpParams} from "@angular/common/http";
import {catchError} from "rxjs/internal/operators";
import {throwError} from "rxjs/index";
import {MatSnackBar} from "@angular/material";
import {Router} from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class GroupsService {

  constructor(private coreService: CoreService, private snackBar: MatSnackBar, private router: Router) { }

    getMyGroups():any {
        return this.coreService.get(`store/my/list`).pipe(map(res => res.data));
    }

    create(data):any{
        return this.coreService.post(`store`, data,[]).subscribe(result => {
            this.snackBar.open('Grupo cadastrado com sucesso!', null, {
                duration: 2000,
                verticalPosition: 'bottom',
                horizontalPosition:'right'
            });
            this.router.navigate(['/admin/groups']);
        });
    }

}
