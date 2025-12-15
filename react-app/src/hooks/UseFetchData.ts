import { useState, useEffect, useCallback } from 'react';
import { buildApiLink } from '../utils/String'

interface FetchResult<T> {
  data: T | null;
  loading: boolean;
  error: string | null;
  refetch: () => Promise<void>;
}

export const useFetchData = <T,>(route: string): FetchResult<T> => {
  const [data, setData] = useState<T | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchData = useCallback(async () => {
    try {
      setLoading(true);
      setError(null);
      
      const response = await fetch(buildApiLink(route), {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      
      if (response.ok) {
        const result = await response.json();
        if (result.success) {
          setData(result.data.preparedData || null);
        } else {
          throw new Error('API returned unsuccessful response');
        }
      } else {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
    } catch (err: any) {
      setError(err.message || 'Failed to fetch data');
      console.error(`Error fetching ${route} data:`, err);
    } finally {
      setLoading(false);
    }
  }, [route]);

  useEffect(() => {
    fetchData();
  }, [fetchData]);

  return { data, loading, error, refetch: fetchData };
};