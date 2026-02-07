import { AxiosInstance } from 'axios';
import { GroupData, UserData } from '@/Types/generated';

declare global {
  interface Window {
    axios: AxiosInstance;
  }
}

export interface AuthUser {
  user: UserData | null;
}

export interface FlashProps {
  message?: string;
  error?: string;
}

export interface Paginated<T> {
  data: T[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

export {};
