export const truncateContent = (content: string, maxLength: number = 50): string => {    
  const truncated = content.substring(0, maxLength);
  const lastSpace = truncated.lastIndexOf(' ');
  
  return lastSpace > 0 
    ? content.substring(0, lastSpace) + '...'
    : truncated + '...';
};
  
export const buildApiLink = (route: string, isAPI: boolean = true): string => {
  const baseUrl = 'http://simplemvc-example.loc/';
  let query: string = '';
  if (isAPI) {
    query = '?api=1&route=';
  } else {
    query = '?route='
  }
  
  return `${baseUrl}${query}${route}`;
}