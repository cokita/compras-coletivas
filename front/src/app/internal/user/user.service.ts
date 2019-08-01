import { Injectable } from '@angular/core';
import {CoreService} from "../../core.service";
import { map,  } from 'rxjs/operators';
import {Users} from "../../shared/models/users";

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private coreService: CoreService) { }

    getUser(){
        const all =JSON.parse(localStorage.getItem('currentUser'));
        if(all.user){
            return all.user;
        }
    }

    search(search:object){
        return this.coreService.get(`user`, search).pipe(
            map(users => users.data)
        );
    }

    async getActions(){
        const actions = await JSON.parse(localStorage.getItem('actions_'+this.getUser().id));
        if(actions){
            return actions;
        }
    }

    getActionsPromise(){
        return new Promise(resolve => {
            const actions =JSON.parse(localStorage.getItem('actions_'+this.getUser().id));
            if(actions){
                resolve(actions);
            }
        });
    }

    getProfiles(){
        const profiles =this.getUser().profiles;
        if(profiles){
            return profiles ;
        }
    }

    hasProfile(profile_id){
        let profiles = this.getProfiles();
        let retorno = false;
        profiles.forEach(obj => {
            if(parseInt(obj.id) === parseInt(profile_id))
                return true;
        });
        return retorno;
    }

    hasOneProfile(arrProfiles){
        let profiles = this.getProfiles();
        let retorno = false;
        profiles.forEach(obj => {
            if (arrProfiles.indexOf(obj.id) !== -1){
                retorno = true;
                return retorno;
            }
        });
        return retorno;
    }

    async verifyAction(action){
        let actions = await this.getActions();
        if (actions && actions.indexOf(action) !== -1){
            return true;
        }

        return false;
    }

    setProfiles(profiles) {
        console.log(profiles);
        let arrAcoesPerfis = [];
        profiles.forEach(objProfiles => {
            let arrAcoes = objProfiles.actions;
            let tagMap = arrAcoes.reduce(function (map, tag) {
                map[tag.id] = tag.name;
                return map;
            }, {});

            if(arrAcoesPerfis.length <= 0){
                arrAcoesPerfis = Object.values(tagMap);
            }else{
                arrAcoesPerfis = arrAcoesPerfis.concat(Object.values(tagMap).filter(function (item) {
                    return arrAcoesPerfis.indexOf(item) < 0;
                }));
            }
        });

        localStorage.setItem('actions_'+this.getUser().id, JSON.stringify(arrAcoesPerfis));

        return arrAcoesPerfis;
    }
}
