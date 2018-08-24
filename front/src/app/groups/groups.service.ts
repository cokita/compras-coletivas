import { Injectable } from '@angular/core';
import { CoreService } from "../core.service";

@Injectable({
    providedIn: 'root'
})
export class GroupsService {
    constructor(private coreService: CoreService) {
    }

    getMyGroups():any {
        return this.coreService.get(`orders/1`);
    }
}
