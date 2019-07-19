import { Injectable } from '@angular/core';
import { map } from 'rxjs/operators';
import {CoreService} from "../../core.service";

@Injectable({
  providedIn: 'root'
})
export class GroupsService {

  constructor(private coreService: CoreService) { }

    getMyGroups():any {
        return this.coreService.get(`store/my/list`).pipe(map(res => res.data));
    }
}