import { Link } from 'react-router-dom';
import { useAuth } from '../../../hooks/UseAuth';
import { useEffect, useState } from 'react';
import { buildApiLink } from '../../../utils/String';

const Footer = () => {
  const { isAllowed } = useAuth();
  const [adminLink, setAdminLink] = useState<string>('/');

  useEffect(() => {
    const getAdminLink = async () => {
      if (await isAllowed('login/login')) {
        setAdminLink(buildApiLink('login/login', false));
      } else if (await isAllowed('admin/adminusers/index')) {
        setAdminLink(buildApiLink('/admin/adminusers/index', false));
      } else {
        setAdminLink('/');
      }
    };
    getAdminLink();
  },[]);

  return (
    <footer className="mt-10 pt-5 text-[0.8em] border-t border-[#00a0b0]">
      <div className="text-gray-700">
        Простая PHP CMS &copy; 2017. Все права принадлежат всем. ;)
        {' '}
        <Link 
          to={adminLink}
          className="underline text-blue-800 visited:text-purple-800 hover:text-blue-600"
        >
          Site Admin
        </Link>
      </div>
    </footer>
  );
};

export default Footer;