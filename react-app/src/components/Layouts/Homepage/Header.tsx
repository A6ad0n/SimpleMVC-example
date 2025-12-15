import { Link } from 'react-router-dom';

const Header = () => (
  <header className="pb-5 mb-9 border-b border-[#00a0b0]">
    <Link to="/" className="block w-fit">
      <img 
        src="../../../../logo.jpg" 
        alt="WidgetNews" 
        className="w-[300px] h-auto"
      />
    </Link>
  </header>
);

export default Header;