export interface Response {
    success: boolean;
    data: {
        preparedData: Object[];
        total: number;
        pageTitle: string;
        timestamp: Date; 
    }
}