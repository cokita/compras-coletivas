import { Injectable } from '@angular/core';

const MENUITEMS = [
    {state: 'home',      type: 'link', name: 'Início', icon: 'av_timer' },
    {state: 'users',     type: 'link', name: 'Usuários', icon: 'person'},
    {state: 'groups',    type: 'link', name: 'Grupos de Vendas', icon: 'shopping_basket'}

];

export interface Menu {
    state: string;
    name: string;
    type: string;
    icon: string;
}

@Injectable({
  providedIn: 'root'
})
export class MenuItensService {

  constructor() { }

    getMenuitem(): Menu[] {
        return MENUITEMS;
    }

}