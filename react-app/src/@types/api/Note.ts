import type { User } from './User'

export interface Note {
    noteId: number;
    noteTitle: string;
    notePublicationDate: string;
    noteContent: string;
    categoryId?: number;
    categoryName?: string;
    subcategoryId?: number;
    subcategoryName?: string;
    noteAuthors: User[];
}