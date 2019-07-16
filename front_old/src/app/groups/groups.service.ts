import { Injectable } from '@angular/core';
import { CoreService } from "../core.service";
import { map } from 'rxjs/operators';

@Injectable({
    providedIn: 'root'
})
export class GroupsService {
    constructor(private coreService: CoreService) {
    }

    getMyGroups():any {
        return this.coreService.get(`store/my/list`).pipe(map(res => res.data));
    }
}
