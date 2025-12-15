import { useCallback } from 'react';
import type { Response } from '../@types/api/Response'
import { buildApiLink } from '../utils/String';

export const useAuth = () => {
  const isAllowed = useCallback(async (route: string): Promise<boolean> => {
    try {
      const url = buildApiLink('auth/index');
      
      const headers: Record<string, string> = {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
      };

      let body: BodyInit | null = null;
  
      body = JSON.stringify({ route: `${route}` });
      headers['Content-Type'] = 'application/json';

      const response = await fetch(url, {
        method: 'POST',
        headers,
        body,
        credentials: 'omit',
        mode: 'cors'
      });


      const result: Response = await response.json();
      
      if (!response.ok || !result.success) {
        return false;
      }

      return Boolean(result.data.preparedData[0]);

    } catch (err: any) {
      console.error('Auth request error:', err);
      return false;
    }
  }, []);

  return { isAllowed };
};