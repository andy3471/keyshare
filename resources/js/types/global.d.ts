import { AxiosInstance } from 'axios';
import { UserData } from '@/Types/generated';

declare global {
  interface Window {
    axios: AxiosInstance;
  }
}

export interface AutocompleteItem {
  id: string;
  name: string;
}

export interface AuthUser {
  user: UserData | null;
}

export interface FlashProps {
  message?: string;
  error?: string;
}

export {};
